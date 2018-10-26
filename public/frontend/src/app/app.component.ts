import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';

/**
 * [Cargamos los Servicios]
 */

import { ConnectionService } from './services/global/connection/connection.service';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  
  /**
   * [Variables de Estado de Conexion]
   */
  public status = this.conn.getStatus(); 
  public sub: Subscription;
  /**
   * [Variables de Estilos]
   */

  public navleftDisplay = false; 

  constructor(
    private conn: ConnectionService
  ) {
    this.sub = this.conn.det().subscribe(d => {
      this.status = d.status;
    });
  }

  ngOnInit() {
  }
  
  /**
   * [Obtenemos el estilo de la navleft y la cambiamos] 
   */

  navleftOperation(event){
    let element = document.getElementById('navleft');
    let estilo = window.getComputedStyle(element, null).getPropertyValue('display');
    if (estilo === 'block') {
      this.navleftDisplay = false;// 'noActivado';
    } else {
      this.navleftDisplay = true;//'activado';
    }
  }

  ngOnDestroy(){
    if(this.sub != undefined){
      this.sub.unsubscribe();
    }
  }
}
