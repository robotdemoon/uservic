import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { CrudService } from '../../../../services/crud/crud.service';

@Injectable({
  providedIn: 'root'
})
export class RequestHelperService {

  constructor(
    private crud: CrudService
  ) { }

  /**
   * [Obtener todos los Budgets Requests]
   */

  getRequest(as: string):Observable<any>{
    let response = new Subject<any>();
    let r = {br: []};
    this.crud.implements(['user', 'requests', 'get'], 0, {t: as}, true).subscribe( d => {
      if(d.e == undefined && d.length && d.length > 0){
        r.br = d;
      }
      response.next(r);
    });
    return response.asObservable();
  }

  /**
   * [Remove Budget Request]
   */

  removeRequest(request: any, budgetRequests: any){
    this.crud.implements(['user','requests', 'remove'], 0, {id_request: +request.id, budget: +request.budget}).subscribe();
    return budgetRequests.filter(h => h !== request);
  }

  /**
   * [Change Status]
   */

  updateRequest(status : string, request: any, budgetRequests: any = []){
    this.crud.implements(['user', 'requests', 'update'], 0, {id_request: +request.id, status: status}).subscribe();
    if(status == 'Ejected' || status == 'Completed Deleted'){
      return budgetRequests.filter(h => h !== request);
    }
  }
}
