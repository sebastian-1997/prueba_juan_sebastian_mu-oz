import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { BusquedaPersonajeComponent } from "./components/busqueda-personaje/busqueda-personaje";


@Component({
  selector: 'app-root',
  standalone: true,
  templateUrl: './app.html',
  styleUrls: ['./app.css'],
  imports: [RouterOutlet],
  
})
export class App {
  protected title = 'frontend';
}
