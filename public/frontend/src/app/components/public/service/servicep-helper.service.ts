import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { CrudService } from '../../../services/crud/crud.service';

/**
 * [Importamos las Constantes]
 */
import { CATEGORIES } from '../../../constants/categories.constant';
import { TYPECOSTS } from '../../../constants/service/type_cost.constant';
import { TYPESERVICES } from '../../../constants/service/type_service.constant';

@Injectable({
  providedIn: 'root'
})
export class ServicepHelperService {
  public response = new Subject<any>();
  constructor(
    private crud: CrudService
  ) { }

  /**
   * [Search Service]
   */

  search(id: string): Observable<any>{
    let r = {s: undefined, c:[], n:[], rest: undefined};
    this.crud.implements(['search', 'services', 'get', 'Public'], 0, {'id': id}).subscribe(
      (d) => {
        if(d.service && d.service != []){
          r.s = d.service;
          this.setService(id, d.service);
          //Encontramos las categorias
          r.s['category_T'] = (CATEGORIES.filter(h => h.category == d.service.category ))[0].value;
          //Encontramos el tipo de costo
          r.s['type_cost_T'] = (TYPECOSTS.filter(h => h.name == d.service.type_cost))[0].value;
          //Encontramos el tipo de servicio
          r.s['type_service_T'] = (TYPESERVICES.filter(h => h.name == d.service.type_service))[0].value;
        if(d.contacts && d.contacts.length > 0){
          for (const x in d.contacts) {
            (d.contacts[x].type == 'Mobile' || d.contacts[x].type == 'Phone' || d.contacts[x].type == 'Email') ? r.c.push(d.contacts[x]): r.n.push(d.contacts[x]);
          }
        }
        if(d.restrictions){
          r.rest = d.restrictions;
        }
      }
        this.response.next(r);
      });
    return this.response.asObservable();
  }

  /**
   * [Obtener Comentarios]
   */

  getComments(id:string): Observable<any>{
    let response = new Subject<any>();
    let r = {comm: [], n: 0};
    this.crud.implements(['services', 'comments', 'get'], 0, {'id': id}).subscribe(
      (d) => {
        if(d.length){
          r.comm = d;
          r.n = d.length;
        }
        response.next(r);
      });
      return response.asObservable();
  }

  /**
   * [Set service in local]
   */
  
  setService(id: string, s: any){
    let a = JSON.parse(localStorage.getItem('previous_services'));
    if(a != undefined && a.length){
      let b = a.filter(h => h.identity == id);
      if(b.length <= 0){
        if(a.length == 12){
          a.pop();
        }
        a.unshift(s);
        localStorage.setItem('previous_services', JSON.stringify(a));
      }
    }else{
      localStorage.setItem('previous_services', JSON.stringify([s]));
    }
  }

  /**
   * [Find Favs]
   */

  findFavourite(id:number){
    let response = new Subject<any>();
    let r = {isFavs: false};
    this.crud.implements(['user', 'favs', 'find'], id, [], true).subscribe(
      (d) => {
        if(d.isFavs != undefined){
          r.isFavs = d.isFavs;
        }
        response.next(r);
      });
    return response.asObservable();
  }

  /**
   * [Add Favorite]
   */

  addFavourite(id:number){
    this.crud.implements(['user', 'favs', 'add'], 0, {'service': +id}).subscribe();
  }

  /**
   * [Remove Favorite]
   */

  removeFavourite(id:string | number){
    this.crud.implements(['user', 'favs', 'remove'], 0, {'service': +id}).subscribe();
  }

  /**
   * [Get Related Services]
   */

  getServicesRelated(category: string, m:number = 3){
    let response = new Subject<any>();
    let r = {s: []};
    this.crud.implements(['services', 'related', 'get'], 0, {'category': category, "min": +m}, true).subscribe(
      (d) => {
        if(d.length){
          r.s = d;
        }
        response.next(r);
      });
    return response.asObservable();
  }

  /**
   * [Add Conexion]
   */

  addConexion(id: number){
    this.crud.implements(['user', 'conexions', 'add'], 0, {conexion: +id}, true).subscribe();
  }


  /**
   * [Add Budget Request]
   */

  addBudgetRequest(data: any){
    this.crud.implements(['user', 'requests', 'add'], 0, data, true).subscribe();
  }

  /**
   * [IsRequest]
   */

  findRequest(data: any){
    let response = new Subject<any>();
    let r = {r: false};
    this.crud.implements(['user', 'requests', 'find'], 0, data, true).subscribe( d => {
      if(d.isRequest != undefined && d.isRequest){ r.r = true;}
      response.next(r);
    });
    return response.asObservable();
  }
}
