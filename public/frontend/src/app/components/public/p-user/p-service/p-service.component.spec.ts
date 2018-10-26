import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PServiceComponent } from './p-service.component';

describe('PServiceComponent', () => {
  let component: PServiceComponent;
  let fixture: ComponentFixture<PServiceComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PServiceComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PServiceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
