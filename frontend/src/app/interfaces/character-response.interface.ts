export interface ApiCharacterResponse {
  results: {
    id: number;
    name: string;
    status: string;
    species: string;
    gender: string;
    image: string;
    episode: string[];
    location: {
      name: string;
    };
  }[];
}
