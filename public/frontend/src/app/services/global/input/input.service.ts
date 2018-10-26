import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class InputService {

  constructor() { }

  /**
   * [Filtrar el array por (name) y devolverlo tipo string o array]
   * @param a 
   * @param reduce 
   * @param typeArray 
   */
  filterCheckbox(a: any, reduce: boolean = false, typeArray: boolean = false, by: string = ''){
    let r = a.filter(h => h.checked == true);
    let c = [];
    if(reduce){
      for (const k in r) {
        (by == '') ? c[k] = r[k].name:c[k] = r[k][by];
      }
      (!typeArray) ? r = c.toString():r = c;
    }
    return r;
  }

  
  /**
   * [Encontrar los items seleccionados en base a (name)]
   * @param a 
   * @param b 
   */

  findCheckbox(a: any, b: any){
    for(const k in b){
      a.filter(h => { if(h.name == b[k]){h.checked = true}});
    }
    return a;
  }
}
