import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { ActivatedRoute } from '@angular/router';

/**
 * [Importamos los Servicios]
 */

import { NavigationService } from '../../../services/global/navigation/navigation.service';
import { ConnectionService } from '../../../services/global/connection/connection.service';


/**
 * [Importar Constantes]
 */

import { URL } from '../../../constants/url.constant';
import { ServicepHelperService } from './servicep-helper.service';

@Component({
  selector: 'app-service',
  templateUrl: './service.component.html',
  styleUrls: ['./service.component.css']
})
export class ServiceComponent implements OnInit{
  public subData: Subscription;
  public subFavs: Subscription;

  public url = URL;
  public idService = '';
  public service;
  public contacts;
  public networks;
  public restrictions;
  public isFavs = false;
  public isRequest = false;
  public isOwnService = false;
  public status = this.conn.getStatus();
  public nComments;
  /**
   * [Variables para solicitud de Presupuesto]
   */
  public budgetRequest = {service_provider: 0, service: 0, description: ''}; 


  /**
   * [Variables de Estilos]
   */
  public hide: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private navigation: NavigationService,
    private conn: ConnectionService,
    private servicepHelper: ServicepHelperService
  ) {
  }


  ngOnInit(){
    this.route.params.subscribe(val => {
      this.idService = this.route.snapshot.params.id;
      this.hide = true;
      window.scrollTo(0, 0);
      this.ngOnDestroy();
      this.searchService();
    });
  }
  /**
   * [Search Service]
   */

  searchService(){
    this.subData = this.servicepHelper.search(this.idService).subscribe(d => {
      this.service = d.s;
      this.contacts = d.c;
      this.networks = d.n;
      this.restrictions = d.rest;
      this.findFavs((this.service != undefined  && this.service.id != undefined) ? +this.service.id : 0 );
      setTimeout(() => {this.hide = false;}, 500);
      //Agregamos los valores a la solicitud de presupuesto
      this.budgetRequest.service_provider = +this.service.user;
      this.budgetRequest.service = +this.service.id;
      this.findRequest();
    });
  }

  /**
   * [Get if is Favs]
   */

  findFavs(id){
    if(id != 0){
      this.subFavs = this.servicepHelper.findFavourite(id).subscribe(d => { this.isFavs = d.isFavs;});
    }
  }

  /**
   * [Find Request]
   */

  findRequest(){
    this.servicepHelper.findRequest({service_provider: +this.service.user, service: +this.service.id}).subscribe(d => {this.isRequest = d.r; console.log(d.r);});
  }

  ngOnDestroy(){
    if(this.subData){this.subData.unsubscribe();}
    if(this.subFavs){this.subFavs.unsubscribe();}
  }
}
