export interface ResultData {
    mainCategory: string;
    mediaType: string;
    signatureAndTopic: string;
    location: LocationData;
}

export interface LocationData {
    label: string;
    imageSrc: string;
}
