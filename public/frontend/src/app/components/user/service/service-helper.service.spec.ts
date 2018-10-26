import { TestBed, inject } from '@angular/core/testing';

import { ServiceHelperService } from './service-helper.service';

describe('ServiceHelperService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ServiceHelperService]
    });
  });

  it('should be created', inject([ServiceHelperService], (service: ServiceHelperService) => {
    expect(service).toBeTruthy();
  }));
});
