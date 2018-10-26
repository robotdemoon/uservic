import { Injectable } from '@angular/core';
import { CrudService } from '../crud.service';

@Injectable({
  providedIn: 'root'
})
export class ContactsService {

  constructor(
    private crud: CrudService
  ) { }

  /**
   * [Eliminar Contacto]
   * [c = contactc, cs = contacts]
   */

  removeContact(c: any, cs: any, id: number = 0){
    cs = cs.filter(h => h !== c);
    if(cs.length <= 0){
      this.addContact(cs);
    }
    if(c.id != ''){
      this.crud.implements(['contacts', 'contacts', 'remove'], 0, ( (id != 0) ? {id_contact: +c.id, id: +id} : {id_contact: +c.id}  )).subscribe();
    }
    return cs;
  }

  /**
   * [Agregar Contacto]
   * [c = contact]
   */

  addContact(c: any){
    c.push({id: null, status: "", type: "", method: "" });
    return c;
  }
}
