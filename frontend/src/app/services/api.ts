import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({ providedIn: 'root' })
export class ApiService {
  private baseUrl = 'http://localhost:8000/api';
  private http = inject(HttpClient);

  getSaludo() {
    return this.http.get<{ mensaje: string }>(`${this.baseUrl}/saludo`);
  }
}
