import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class DesignService {
  
  /**
   * [Mostrar u Ocultar Item]
   */

  visibilityItem(r){
    (!r) ? r = true: r = false;
    return r;
  }
}
