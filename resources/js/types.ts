export interface ItemsResource {
    data: Array<ItemData>;
}

export interface ItemData {
    topic: string;
    signature: string;
    location: LocationData;
    mediaType: string;
    category1: string;
    category2: string;
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

export interface TopicsResource {
    data: Array<TopicData>;
}

export interface TopicResource {
    data: TopicData;
}

export interface TopicData {
    id: number;
    name: string;
}
