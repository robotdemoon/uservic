import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ServiceSuggestedComponent } from './service-suggested.component';

describe('ServiceSuggestedComponent', () => {
  let component: ServiceSuggestedComponent;
  let fixture: ComponentFixture<ServiceSuggestedComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ServiceSuggestedComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ServiceSuggestedComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
