import { Routes } from '@angular/router';
import { BusquedaPersonajeComponent } from './components/busqueda-personaje/busqueda-personaje';
import { ReportesComponent } from './components/reportes/reportes';


export const routes: Routes = [
  { path: '', component: BusquedaPersonajeComponent },
  { path: 'reportes', component: ReportesComponent }
];
