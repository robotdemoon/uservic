import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ArrayService {

  constructor() { }
  
  /**
   * 
   * @param a 
   * [Revisa que el array no ocontenga valores tales como '', null, 0 y manda un estado]
   */
  isEmpty(a: any){
    let x = 0;
    let status;
    for (const k in a) {
      if(a[k] != '' && a[k] != null && a[k] != 0){
        x++;
      }
    }
    (x > 0) ? status = false: status = true;
    return status;
  }

  isEqual(a:any, b:any){
    let x = 0;
    let status;
    for (const k in a) {
      if(a[k] != b[k]){
        b[k] = a[k];
        x++;
      }
    }
    (x > 0) ? status = false: status = true;
    return status;
  }
}
