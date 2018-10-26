import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PUserComponent } from './p-user.component';

describe('PUserComponent', () => {
  let component: PUserComponent;
  let fixture: ComponentFixture<PUserComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PUserComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
