<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Item;
use App\Models\Location;
use App\Models\MediaType;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImportItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-items  {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports items.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $file = Storage::get($this->argument('path'));
                $lines = explode(PHP_EOL, $file);
                array_shift($lines);

                Item::query()->delete();
                Category::query()->delete();
                Location::query()->delete();
                MediaType::query()->delete();

                $this->importCategories($lines);
                $this->importLocations($lines);
                $this->importMediaTypes($lines);
                $this->importItems($lines);
            });
        } catch (ModelNotFoundException $e) {
            $this->error('Model not found: ' . $e->getMessage());
        } catch (Throwable $t) {
            $this->error('An error occurred: ' . $t->getMessage());
        }
    }

    private function importCategories($lines)
    {
        $categoryMappings = [];
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            $categoryName = $data[4];
            $subCategoryName = $data[5];
            if ($categoryName != 'Alle Kategorien (wenn möglich nicht nutzen)' && $categoryName && !isset($categoryMappings[$categoryName])) {
                $this->info("Creating category $categoryName");
                $category = new Category();
                $category->name = $categoryName;
                $category->save();
                $categoryMappings[$categoryName] = $category->id;
            }
            if ($subCategoryName && !isset($categoryMappings[$subCategoryName])) {
                $this->info($categoryName . "=>" . $subCategoryName);
                $this->info("Creating category $subCategoryName as subcategory of $categoryName");
                $subcategory = new Category();
                $subcategory->name = $subCategoryName;
                $subcategory->parent_id = $categoryMappings[$categoryName];
                $subcategory->save();
                $categoryMappings[$subCategoryName] = $subcategory->id;
            }
        }
        $count = count($categoryMappings);
        $this->info("$count categories created");
    }

    private function importLocations($lines)
    {
        $locationNames = [];
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            $locationName = $data[2];
            if ($locationName && !isset($locationNames[$locationName])) {
                $this->info("Creating location $locationName");
                $locationNames[$locationName] = true;
                $location = new Location();
                $location->name = $locationName;
                $location->save();
            }
        }
        $count = count($locationNames);
        $this->info("$count locations created");
    }

    private function importMediaTypes($lines)
    {
        MediaType::query()->delete();
        $mediaTypeNames = [];
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            $mediaTypeName = $data[3];
            if ($mediaTypeName && !isset($mediaTypeNames[$mediaTypeName])) {
                $this->info("Creating media type $mediaTypeName");
                $mediaTypeNames[$mediaTypeName] = true;
                $mediaType = new MediaType();
                $mediaType->name = $mediaTypeName;
                $mediaType->save();
            }
        }
        $count = count($mediaTypeNames);
        $this->info("$count media types created");
    }

    private function importItems($lines)
    {
        $i = 0;
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            if (!array_filter($data)) {
                continue;
            }
            $i++;
            $this->info("Creating item $i");
            $topic = $data[0];
            $signature = $data[1];
            $location = Location::where('name', $data[2])->firstOrFail();
            $mediaType = MediaType::where('name', $data[3])->firstOrFail();
            $categoryString = $data[4];
            $category = null;
            if ($categoryString != 'Alle Kategorien (wenn möglich nicht nutzen)') {
                $category = Category::where('name', $data[4])->firstOrFail();
            }
            $item = new Item();
            $item->topic = $topic;
            $item->signature = $signature;
            $item->location_id = $location->id;
            $item->media_type_id = $mediaType->id;
            if ($data[5]) {
                $subcategory = Category::where('name', $data[5])->firstOrFail();
                $item->category_id = $subcategory->id;
            } else {
                $item->category_id = $category ? $category->id : null;
            }
            $item->save();
        }
        $this->info("$i items created");
    }
}
