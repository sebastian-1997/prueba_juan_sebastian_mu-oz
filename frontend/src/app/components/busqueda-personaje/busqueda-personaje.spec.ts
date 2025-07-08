import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BusquedaPersonaje } from './busqueda-personaje';

describe('BusquedaPersonaje', () => {
  let component: BusquedaPersonaje;
  let fixture: ComponentFixture<BusquedaPersonaje>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BusquedaPersonaje]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BusquedaPersonaje);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
