import { TestBed, inject } from '@angular/core/testing';

import { CovertureService } from './coverture.service';

describe('CovertureService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CovertureService]
    });
  });

  it('should be created', inject([CovertureService], (service: CovertureService) => {
    expect(service).toBeTruthy();
  }));
});
