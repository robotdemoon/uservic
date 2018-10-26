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
   * [Add Costumer]
   */

  addCostumer(id: string | number){
    this.crud.implements(['user', 'costumers', 'add'], 0, {costumer: +id} ).subscribe();
  }
}
