import { TestBed, inject } from '@angular/core/testing';

import { UserHelperService } from './user-helper.service';

describe('UserHelperService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [UserHelperService]
    });
  });

  it('should be created', inject([UserHelperService], (service: UserHelperService) => {
    expect(service).toBeTruthy();
  }));
});
