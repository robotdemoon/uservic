import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { CrudService } from '../../../services/crud/crud.service';

@Injectable({
  providedIn: 'root'
})
export class CostumerHelperService {

  constructor(
    private crud: CrudService
  ) { }

  /**
   * [Get Costumers]
   */

  getCostumers():Observable<any>{
    let response = new Subject<any>();
    let r = {c: []};
    this.crud.implements(['user', 'costumers', 'get'], 0, [], true).subscribe( d => {
      if(d.e == undefined && d.length > 0){
        r.c = d;
      }
      response.next(r);
    });
    return response.asObservable();
  }

  /**
   * [Remove Costumer]
   */

  removeCostumer(costumer: any, costumers: any){
    this.crud.implements(['user','costumers', 'remove'], 0, {id: +costumer.id} ).subscribe();
    return costumers.filter(h => h !== costumer);
  }
}
