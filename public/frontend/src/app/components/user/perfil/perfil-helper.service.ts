import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, Subject} from 'rxjs';
import { CrudService } from '../../../services/crud/crud.service';
import { ContactsService } from '../../../services/crud/contacts/contacts.service';
import { InputService } from '../../../services/global/input/input.service';

@Injectable({
  providedIn: 'root'
})
export class PerfilHelperService {
  public response = new Subject<any>();
  constructor(
    private crud: CrudService,
    private router: Router,
    private conts: ContactsService,
    private input: InputService
  ) { }

  /**
   * [Get Data]
   */

  getData(t: string = ''): Observable<any>{
    let r = {u: [], c: []};
    this.crud.implements(['user', 'perfil', 'get' + t ], 0, [], true).subscribe(
      (d) => {
        if(d.perfil != undefined){
          r.u = d.perfil;
          if(d.contacts != undefined && d.contacts.length > 0 ){
            r.c = d.contacts;
          }
        }
        this.response.next(r);
      });
    return this.response.asObservable();
  }

  /**
   * [Update Data]
   */

  updateData(u:any, c: any, i:any){
    u.interests = this.input.filterCheckbox(i, true);
    this.crud.implements(['user', 'perfil', 'update'], 0, {perfil: u, contacts: c}).subscribe((d) => {
      if(!d.e){
        this.router.navigate(['usr']);
      }else{
        console.log(d);
      }
    });
  }
}
