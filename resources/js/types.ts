export interface ItemsResource {
    data: Array<ItemData>;
}

export interface ItemResource {
    data: ItemData;
}

export interface ItemData {
    id: number;
    topic: string;
    signature: string;
    location: LocationData;
    mediaType: MediaTypeData;
    category: CategoryData;
}

export interface CategoriesResource {
    data: Array<CategoryData>;
}

export interface CategoryResource {
    data: CategoryData;
}

export interface CategoryData {
    id: number;
    name: string;
    parent?: CategoryData;
    children: Array<CategoryData>;
}

export interface UserResource {
    data: UserData;
}

export interface UserData {
    id: number;
    name: string;
}

export interface LocationsResource {
    data: Array<LocationData>;
}

export interface LocationResource {
    data: LocationData;
}

export interface LocationData {
    id: number;
    name: string;
    imageSrc: string;
    imageAlt: string;
}

export interface MediaTypesResource {
    data: Array<MediaTypeData>;
}

export interface MediaTypeResource {
    data: MediaTypeData;
}

export interface MediaTypeData {
    id: number;
    name: string;
}

export interface SearchParams {
    search?: string;
    categoryIds?: Array<string>;
    locationIds?: Array<string>;
    mediaTypeIds?: Array<string>;
}
