import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { inject } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiCharacterResponse } from '../interfaces/character-response.interface';



@Injectable({
  providedIn: 'root',
})
export class ApiService {
  private http = inject(HttpClient);
  private apiUrl = 'http://127.0.0.1:8000/api'; // Asegúrate de que sea tu URL del backend

  // Buscar personajes por nombre
  buscarPersonajes(nombre: string): Observable<ApiCharacterResponse> {
  return this.http.get<ApiCharacterResponse>(`https://rickandmortyapi.com/api/character/?name=${nombre}`);
}


  // Obtener detalles de personaje 
  obtenerDetalle(id: number): Observable<any> {
    return this.http.get(`${this.apiUrl}/personajes/${id}`);
  }

  // Importar personaje por ID 
  importarPersonaje(id: number): Observable<any> {
  return this.http.post(`${this.apiUrl}/importar/personaje`, { id });
}


  // Reporte: personajes ordenados por fecha
  getReportePersonajesOrdenados(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/reportes/personajes`);
  }

  // Reporte: cantidad de personajes por episodio
  getReportePersonajesPorEpisodio(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/reportes/episodios`);
  }

  // Reporte: personajes agrupados por locación
  getReportePersonajesPorLocacion(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/reportes/locaciones`);
  }
}
