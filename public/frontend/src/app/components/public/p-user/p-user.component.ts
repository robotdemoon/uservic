import { Component } from '@angular/core';
import { Subscription } from 'rxjs';
import { PUserHelperService } from './p-user-helper.service';
import { ActivatedRoute } from '../../../../../node_modules/@angular/router';
/**
 * [Importamos Constantes]
 */
import { URL } from '../../../constants/url.constant';

@Component({
  selector: 'app-p-user',
  templateUrl: './p-user.component.html',
  styleUrls: ['./p-user.component.css']
})
export class PUserComponent {

  /**
   * [Varibles para metodos]
   */
  public userSub: Subscription;
  public servicesSub: Subscription;
  public routeSub: Subscription;

  /**
   * [Constantes]
   */

  public url = URL.user;
  
  /**
   * [Variables para componentes]
   */
  public user;
  public contacts;
  public image;
  public services;

  /**
   * [Varibles de Estilo]
   */

  public hide;
  public status = 'perfil';

  constructor(
    private route: ActivatedRoute,
    private pUserHelper: PUserHelperService
  ) { 

    this.routeSub = this.route.params.subscribe(val => {
      let username = this.route.snapshot.params.username;
      this.status = this.route.snapshot.params.status;
      this.hide = true;
      window.scrollTo(0, 0);
      if(this.userSub == undefined){
        this.getData(username);
      }else if(this.servicesSub == undefined && this.status == 'services'){
          this.getServices(this.user.username);
      }else{
        setTimeout(() => {this.hide = false;}, 500);
      }
    });
  }


  /**
   * [Obtener Data]
   */

  getData(username:string){
    this.userSub = this.pUserHelper.getData(username).subscribe( d => {
      this.user = d.u;
      this.contacts = d.c;
      this.image = d.u.image;
      if(this.status == 'services'){this.getServices(d.u.username);}
      setTimeout(() => {this.hide = false;}, 1000);
    });
  }

  /**
   * [Obtener Servicios]
   */

  getServices(id:string){
    this.servicesSub = this.pUserHelper.getServices(id).subscribe(d => {this.services = d.s;});
    setTimeout(() => {this.hide = false;}, 1000);
  }

  ngOnDestroy(){
    if(this.userSub){this.userSub.unsubscribe();}
    if(this.servicesSub){this.servicesSub.unsubscribe();}
    if(this.routeSub){this.routeSub.unsubscribe();}
  }
}
