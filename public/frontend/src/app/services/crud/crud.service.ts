import { Injectable } from '@angular/core';
import { Http, Response, Headers } from '@angular/http';
import { Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { TokenService } from '../tkn/token.service'
import { ConnectionService } from '../global/connection/connection.service';

const httpOptions = {
  headers: new Headers({ 'Content-Type': 'application/x-www-form-urlencoded' })
};

@Injectable({
  providedIn: 'root'
})
export class CrudService {
  private apiUrl = 'http://localhost/uservic_test/public/';
  constructor(
    private http: Http,
    private tkn: TokenService,
    private conn: ConnectionService
  ) { 
  }

  /**
   * 
   * @param entity #[controller, method, action, +action]
   * @param id 
   * @param data 
   * @param tkn_status 
   */
  implements(entity:any, id: number | string = 0, data:any = [], tkn_status: boolean = false){
    let tkn =  this.tkn.getTkn();
    let params = "d=" + JSON.stringify( (( tkn_status || tkn != false )  ? {token:  tkn, id: id, data: data, action: entity[2] + ((entity[3]) ? entity[3]:'') } : {id:id, data: data, action:  entity[2] + ((entity[3]) ? entity[3]:'') }) ); 

    return this.http.post(this.apiUrl + entity[0] + '/' + entity[1], params, httpOptions).pipe(
      map((res) => {
          let r = res.json();
          if(r.t != undefined && r.t == 'token' && r.e){
            this.conn.logOut();
            return [];
          }else if(r.e == undefined || (!r.e && entity[2] == 'get' ) || (r.e != undefined && entity[2] != 'get' ) ){
            return r;
          }else{
            return [];
          }
        }
      ),
      catchError(this.handleError<any>(entity[2] + '/' + entity[0]))
    );
  }

  /**
   * [Agregar Registro]
   */

  image(entity:any, image, data:any = []){
    let tkn = this.tkn.getTkn();
    let params = JSON.stringify({token: tkn, data: data, action: ((entity[2] == undefined ) ? 'image' : entity[2])});
    image.append('d', params);
    return this.http.post(this.apiUrl + entity[0] + '/' + entity[1], image)
    .pipe(
      map((res: Response) => res.json()),
      catchError(this.handleError<any>('image' + entity[0]))
    );
  }

  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead
      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }
}
