import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { CrudService } from '../../services/crud/crud.service';

@Injectable({
  providedIn: 'root'
})
export class UserHelperService {

  constructor(
    private crud: CrudService
  ) { }


  /**
   * [Conexions]
   */
  
  getConexions(): Observable<any>{
    let response = new Subject<any>();
    let r = {c: []};
    this.crud.implements(['user', 'conexions', 'get'], 0, [], true).subscribe(d => {
      if(d.e == undefined){
        r.c = d;
      }
      response.next(r);
    });
    return response.asObservable();
  }

  updateConexion(data: any){
    this.crud.implements(['user', 'conexions', 'update'], 0, data).subscribe();
  }

  removeConexion(id: string){
    this.crud.implements(['user', 'conexions', 'remove'], 0, {id: +id}).subscribe();
  }

  /**
   * [Settings]
   */
  getSettings(): Observable<any>{
    let response = new Subject<any>();
    let r = {s: []};
    this.crud.implements(['user', 'settings', 'get'], 0, [], true).subscribe(d => {
      if(d.e == undefined){
        r.s = d;undefined
      }
      response.next(r);
    });
    return response.asObservable();
  }
  
  updateSettings(settings:any){
    this.crud.implements(['user', 'settings', 'update'], 0, settings).subscribe();
  }
}
