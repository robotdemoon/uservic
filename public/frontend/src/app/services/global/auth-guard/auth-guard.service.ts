import { Injectable } from '@angular/core';
import { Router, CanActivate } from '@angular/router';
import { ConnectionService } from '../connection/connection.service';

@Injectable({
  providedIn: 'root'
})
export class AuthGuardService implements CanActivate {

  constructor(
    public router: Router,
    public conn: ConnectionService
    ) {  }
  canActivate() {
    if (!this.conn.getStatus()) {
      this.conn.logOut();
      return false;
    }else{
      return true;
    }
  }
}
