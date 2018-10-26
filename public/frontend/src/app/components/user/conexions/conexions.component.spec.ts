import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConexionsComponent } from './conexions.component';

describe('ConexionsComponent', () => {
  let component: ConexionsComponent;
  let fixture: ComponentFixture<ConexionsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConexionsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConexionsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
