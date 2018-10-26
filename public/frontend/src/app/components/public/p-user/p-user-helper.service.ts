import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { CrudService } from '../../../services/crud/crud.service';

@Injectable({
  providedIn: 'root'
})
export class PUserHelperService {
  constructor(
    private crud: CrudService,
  ) { }

  /**
   * [Get Data]
   */

  getData(username: string): Observable<any>{
    let response = new Subject<any>();
    let r = {u: [], c: []};
    this.crud.implements(['search', 'perfil','get', 'Public'], 0, {id:username}).subscribe(
      (d) => {
        if(d.e == undefined && d.perfil != undefined && d.perfil.e == undefined ){
          r.u = d.perfil;
          if(d.contacts != undefined && d.contacts.length > 0 && d.contacts.e == undefined){
            r.c = d.contacts;
          }
        }
        response.next(r);
      });
    return response.asObservable();
  }

  /**
   * [Get Services]
   */
  
  getServices(id: string): Observable<any>{
    let response = new Subject<any>();
    let r = {s: []};
    this.crud.implements(['services', 'related','get', 'UserRelated'], 0, {user: id}).subscribe(
      (d) => {
        if(d.e == undefined){
          r.s = d;
        }
        response.next(r);
      });
    return response.asObservable();
  }
}
