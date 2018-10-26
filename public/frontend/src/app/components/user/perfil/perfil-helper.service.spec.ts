import { TestBed, inject } from '@angular/core/testing';

import { PerfilHelperService } from './perfil-helper.service';

describe('PerfilHelperService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [PerfilHelperService]
    });
  });

  it('should be created', inject([PerfilHelperService], (service: PerfilHelperService) => {
    expect(service).toBeTruthy();
  }));
});
