import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { TokenService } from '../../../services/tkn/token.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common'
import { RoutingStateService } from '../../../services/global/navigation/routing-state/routing-state.service';
@Injectable({
  providedIn: 'root'
})
export class ConnectionService {
  private subject = new Subject<any>();
  constructor(
    private router: Router,
    public location: Location,
    private tkn: TokenService,
    private routing: RoutingStateService
  ){
    this.routing.loadRouting();
  }


  /**
   * [Si estas conectado te autoredirige]
   */
  autoOffline(){
    if(this.getStatus()){
      this.router.navigate(['']);
    } 
  }
  /**
   * [Estado actual de la conexion]
   */

  getStatus(){
    return this.tkn.isAuthenticated();
  }

  /**
   * [Loguearte una vez obtenido el Tkn]
   */

  logIn(v:any){
    this.tkn.addData('tkn', v);
    this.subject.next({status: true});
    (this.routing.getStateUrl()) ? this.location.back(): this.router.navigate(['']);
  }

  /**
   * [Cerrar sesion]
   */

  logOut(){
    this.subject.next({status: false});
    this.tkn.removeData('tkn');
    this.router.navigate(['login']);
  }

  /**
   * [Detecta cambios en la conexion]
   */
  
  det(): Observable<any>{
    return this.subject.asObservable();
  }
}
