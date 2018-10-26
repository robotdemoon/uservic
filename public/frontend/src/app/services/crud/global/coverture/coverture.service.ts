import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { CrudService } from '../../crud.service';

@Injectable({
  providedIn: 'root'
})
export class CovertureService {
  public countries;
  constructor(
    private crud: CrudService
  ) { }

  
  getCountries(): Observable<any>{
    return this.crud.implements(['coverage', 'search', 'get','Countries']);
  }

  covertureChange(id, x): Observable<any>{
    return this.crud.implements(['coverage', 'search', 'get', x], +id);
  }
}
