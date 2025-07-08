import { Component, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ApiService } from '../../services/api.service';
import { ApiCharacterResponse } from '../../interfaces/character-response.interface';
import Swal from 'sweetalert2';
import { Router } from '@angular/router';




@Component({
  selector: 'app-busqueda-personaje',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './busqueda-personaje.html',
  styleUrls: ['./busqueda-personaje.css'],
})
export class BusquedaPersonajeComponent {
  private router = inject(Router);
  private apiService = inject(ApiService);

  terminoBusqueda = '';
  personajes = signal<any[]>([]);
  personajeSeleccionado = signal<any | null>(null);
  mensaje = signal('');
  nombreBuscado: any;

  buscar() {
    if (!this.terminoBusqueda.trim()) return;

    this.apiService.buscarPersonajes(this.terminoBusqueda).subscribe({
      next: (data: ApiCharacterResponse) => {
        this.personajes.set(data.results || []);
        this.mensaje.set('');
        this.personajeSeleccionado.set(null);
      },
      error: () => this.mensaje.set('No se encontraron personajes.'),
    });

  }

  seleccionar(personaje: any) {
    this.personajeSeleccionado.set(personaje);
    this.mensaje.set('');
  }

  importar(personaje: any) {
  // Mostrar loader mientras se importa
  Swal.fire({
    title: 'Importando personaje...',
    text: 'Por favor espera.',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading(); // Mostrar spinner
    }
  });

  this.apiService.importarPersonaje(personaje.id).subscribe(
    (res: any) => {
      Swal.close(); // Cierra el loader

      // Mostrar éxito
      Swal.fire({
        icon: 'success',
        title: '¡Importado correctamente!',
        text: res.mensaje || 'El personaje fue guardado en la base de datos.',
        timer: 2000,
        showConfirmButton: false
      });

      // Cerrar modal y actualizar lista
      this.cerrarModal();
      this.buscar();
    },
    () => {
      Swal.close(); // Cierra el loader si falla

      // Mostrar error
      Swal.fire({
        icon: 'error',
        title: 'Error al importar',
        text: 'No se pudo guardar el personaje.',
      });
    }
  );
}




  cerrarModal() {
    this.personajeSeleccionado.set(null);
  }

  irAReportes() {
    this.router.navigate(['/reportes']);
  }

}
