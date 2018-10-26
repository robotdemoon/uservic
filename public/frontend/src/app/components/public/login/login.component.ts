import { Component, OnInit} from '@angular/core';
import { Subscription, Observable } from 'rxjs';
/**
 * [Importamos los Servicios]
 */

import { CrudService } from '../../../services/crud/crud.service';
import { ConnectionService } from '../../../services/global/connection/connection.service';
/**
 * [Importar Modelos]
 */

import {UserS, UserL} from './user-login.model';

/**
 * [Importamos las Constantes]
 */
import { CATEGORIES } from '../../../constants/categories.constant';
import { SCHOLARSHIPS } from '../../../constants/scholarship.constant';
import { URL } from '../../../constants/url.constant';
import { CovertureService } from '../../../services/crud/global/coverture/coverture.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  /**
   * Variables de Formularios
   */

  public user_login = new UserL();
  public user_signin =  new UserS();
  public pwd_confirm = '';
  public countries$: Observable<any> = this.coverture.getCountries();

  /**
   * [Variables de Estilo]
   */
  public statusForm = false;
   /**
    * [Constantes]
    */

  public categories = CATEGORIES;
  public scholarships = SCHOLARSHIPS;
  public url = URL.general;

  /**
   * [Variables de Metodos]
   */

  public login_sub: Subscription;
  public signin_sub: Subscription;
  constructor(
    private crud: CrudService,
    private conn: ConnectionService,
    private coverture: CovertureService
  ) { 
    this.conn.autoOffline();
  }

  ngOnInit() {
  }

  /**
   * [Verificar Usuario]
   */
  logIn(){
    this.login_sub = this.crud.implements(['login', 'login', 'find'], 0, this.user_login).subscribe(
      (d) => {
        console.log(d);
        if(!d.e  && d.tkn != undefined){
          this.conn.logIn(d.tkn);
        }else{
          console.log('Invalid Email or Password')
        }
      });
  }

  /**
   * Registrar Usuario
   */

  /*signIn(){
    this.signin_sub = this.crud.add(['login', 'user'],  this.user_signin, '', false).subscribe(
    (d) => {
      if(!d.e){
        this.user_login = {email: this.user_signin.email, pwd: this.user_signin.password};
        this.logIn();
      }else{
        console.log(d.m);
      }
    });
  }*/

  ngOnDestroy(){
    if(this.login_sub != undefined){
      this.login_sub.unsubscribe();
    }
    if(this.signin_sub != undefined){
      this.signin_sub.unsubscribe();
    }
  }
}
