import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, Subject } from 'rxjs';
import { CrudService } from '../../../services/crud/crud.service';

/**
 * [Importamos las Constantes]
 */
import { CATEGORIES } from '../../../constants/categories.constant';
import { TYPECOSTS } from '../../../constants/service/type_cost.constant';
import { TYPESERVICES } from '../../../constants/service/type_service.constant';
import { BudgetService } from './budget.model';
@Injectable({
  providedIn: 'root'
})
export class BudgetHelperService {

  constructor(
    private router: Router,
    private crud: CrudService
  ) { }


  /**
   * [Agregar budgets]  
   */

  addBudget(data: any): Observable<any>{
    let response = new Subject<any>();
    this.crud.implements(['user', 'budgets', 'add'], 0, data).subscribe( d => {
      if(!d.e){
        this.router.navigate(['usr/budget/request']);
        d = [];
      }
      response.next(d);
    });
    return response.asObservable();
  }

  /**
   * [Obtener la Vista del Budget]
   */

  getViewBudget(id: number, t: string = 'user'):Observable<any>{
    let response = new Subject<any>();
    let r = {b: [], bs: [], c: [], n: []};
    this.crud.implements(['user', 'budgets', 'get'], id, {'t':t}, true).subscribe( d => {
      if(d.e == undefined){
        if( d.budget != undefined && d.budget.e == undefined){
          r.b = d.budget;
          //Hay que reducir esto
          r.b['category'] = (CATEGORIES.filter(h => h.category == d.budget.category ))[0].value;
          r.b['type_cost'] = (TYPECOSTS.filter(h => h.name == d.budget.type_cost))[0].value;
          r.b['type_service'] = (TYPESERVICES.filter(h => h.name == d.budget.type_service))[0].value;
        }
        if(d.services != undefined && d.services.e == undefined){
          r.bs = d.services;
        }
        if(d.contacts != undefined && d.contacts.e == undefined){
          for (const x in d.contacts) {
            if(d.contacts[x].type == 'Mobile' || d.contacts[x].type == 'Phone' || d.contacts[x].type == 'Email') {
              r.c.push(d.contacts[x]);
            }else{
              r.n.push(d.contacts[x]);
            }
          }
        }
      }
      response.next(r);
    });
    return response.asObservable();
  }
  
  /**
   * -----------[Metodos Miscelaneos]
   */
  
  calcTotal(a: any){
    let r = 0;
    for (const x in a) {
      let m = +(a[x].number * a[x].cost);
      r = +(r + m);
    }
    return +r.toFixed(2);
  }

  addOneBudget(a: any){
    a.push(new BudgetService());
    return a;
  }

  removeOneBudget(budget: any, a: any){
    a = a.filter(h => h !== budget);
    if(a.length <= 0 ){ return this.addOneBudget(a);}else{ return a;}
  }
}
