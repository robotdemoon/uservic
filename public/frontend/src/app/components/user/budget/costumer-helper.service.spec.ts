import { TestBed, inject } from '@angular/core/testing';

import { CostumerHelperService } from './costumer-helper.service';

describe('CostumerHelperService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CostumerHelperService]
    });
  });

  it('should be created', inject([CostumerHelperService], (service: CostumerHelperService) => {
    expect(service).toBeTruthy();
  }));
});
