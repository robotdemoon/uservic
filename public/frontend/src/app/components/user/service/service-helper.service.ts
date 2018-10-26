import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, Subject } from 'rxjs';
import { CrudService } from '../../../services/crud/crud.service';
import { ContactsService } from '../../../services/crud/contacts/contacts.service';
import { ImageService } from '../../../services/crud/image/image.service';
@Injectable({
  providedIn: 'root'
})
export class ServiceHelperService {
  constructor(
    private crud: CrudService,
    private conts: ContactsService,
    private imageService: ImageService,
    private router: Router
  ) { }

  /**
   * [Obtener servicio del usuario]
   */

  getService(id): Observable<any> {
    let response = new Subject<any>();
    let r = {s: [], c:[], isState: false};
    this.crud.implements(['user', 'services', 'get', 'Edit'], 0, {id: id}, true).subscribe(
      (d) => {
        if(d.service){
          if(d.service.state != null){r.isState = true;}
          r.s = d.service;
          if(d.contacts && d.contacts.length > 0 && d.contacts.e == undefined){
            d.contacts.filter(h => h.order = h.id);
            r.c = d.contacts;
          }else if(d.contacts.length <= 0 || d.contacts.e != undefined){
            r.c = this.conts.addContact(r.c);
          }
          response.next(r);
        }else{
          this.router.navigate(['usr/my-services']);
        }
      });
    return response.asObservable();
  }

  /**
   * [Actualizar Servicio]
   */

  updateService(s:any, c: any, id: string){
    let contacts = JSON.parse( JSON.stringify( c ) ).filter(h => delete h.order);
    this.crud.implements(['user', 'services', 'update'], 0, {service: s, contacts: contacts}).subscribe((d) => {
      if(!d.e){
        this.router.navigate(['service', id]);
      }else{
        console.log(d);
      }
    });
  }

  /**
   * [Create Service]
   */

  createService(i:any, s:any, c:any): Observable<any>{
    let response = new Subject<any>();
    let r = {i: ''}
    if(i == '' || i == undefined){
      i = new FormData();
      i.append('image', '');
    }
    let contacts = JSON.parse( JSON.stringify( c ) ).filter(h => delete h.order).filter(h => delete h.id);
    this.crud.image(['user', 'services', 'add'], i, {service: s, contacts: contacts}).subscribe((d) => {
      if(!d.e){
        this.router.navigate(['service/', d.id]);
      }else{
        r.i = 'nopicture.jpg';
      }
      response.next(r);
    });
    return response.asObservable();
  }

  /**
   * [Get Favourite Services]
   */

  getFavs(): Observable<any>{
    let response = new Subject<any>();
    let r = {s: []};
    this.crud.implements(['user', 'favs', 'get'], 0, [], true).subscribe(d => {
      if(d.e == undefined && d.length > 0){
        r.s = d;
      }
      response.next(r);
    });
    return response.asObservable();
  }
}
