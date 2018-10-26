import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PPerfilComponent } from './p-perfil.component';

describe('PPerfilComponent', () => {
  let component: PPerfilComponent;
  let fixture: ComponentFixture<PPerfilComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PPerfilComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PPerfilComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
