import { Component, inject, OnInit, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiService } from '../../services/api.service';

@Component({
  selector: 'app-reportes',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './reportes.html',
  styleUrls: ['./reportes.css'],
})
export class ReportesComponent implements OnInit {
  private api = inject(ApiService);

  reporteOrdenado = signal<any[]>([]);
  reportePorEpisodio = signal<any[]>([]);
  reportePorLocacion = signal<any[]>([]);

  reporteActivo = 'ordenado'; // default

  ngOnInit() {
    this.api.getReportePersonajesOrdenados().subscribe(data => this.reporteOrdenado.set(data));
    this.api.getReportePersonajesPorEpisodio().subscribe(data => this.reportePorEpisodio.set(data));
    this.api.getReportePersonajesPorLocacion().subscribe(data => this.reportePorLocacion.set(data));
  }

  mostrarReporte(tipo: 'ordenado' | 'episodio' | 'locacion') {
    this.reporteActivo = tipo;
  }
}
