import { TestBed, inject } from '@angular/core/testing';

import { QueryStructService } from './query-struct.service';

describe('QueryStructService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [QueryStructService]
    });
  });

  it('should be created', inject([QueryStructService], (service: QueryStructService) => {
    expect(service).toBeTruthy();
  }));
});
