import { Injectable } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';

@Injectable({
  providedIn: 'root'
})
export class TokenService {
  public token;
  public a = 0;
  public JWTHelper = new JwtHelperService();

  /**
   * [Metodo para Autenticar el Token]
   */
  public isAuthenticated() {
    let status = false;
    this.token = JSON.parse(localStorage.getItem('tkn'));
    if (this.token !== 'undefined' && this.token !== null && this.token !== 'error') {
      if (!this.JWTHelper.isTokenExpired(this.token)) {
        status = true;
      }
    }
    return status;
  }

  /**
   * [Metodo para obtener la información del token]
   */
  public getDataTkn(){
    let s;
    this.token = JSON.parse(localStorage.getItem('tkn'));
    if (this.token !== 'undefined' && this.token !== null && this.token !== 'error') {
      s = this.JWTHelper.decodeToken(this.token);
    }else{
      s = {e: true, m: 'Invalid Token'};
    }
    return s;
  }

  /**
   * [Obtener Token]
   */

  public getTkn(){
    if(this.isAuthenticated()){
      return this.token;
    }else{
      return false;
    }
  }
  /**
   * [Remover local Data]
   */
  public removeData(v: string){
    localStorage.removeItem(v);
  }

  /**
   * [Agregar Local Data]
   */
  public addData(n:string, v:any){
    localStorage.setItem(n, JSON.stringify(v));
  }
}
