import { Injectable } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class QueryStructService {
  public params;
  constructor(
    private route: ActivatedRoute
  ) { }

  /**
   * 
   * @param Strg 
   * [Estructura y Regresa la query para su busqueda]
   */
  structQuery(Strg:string){
    let query = '';
      const b = Strg.split('+');
      for (const k in b) {
        if (b[k] != ''){
          query +=b[k]+' ';  
        } 
      }
    return query.slice(0, -1);
  }
}
