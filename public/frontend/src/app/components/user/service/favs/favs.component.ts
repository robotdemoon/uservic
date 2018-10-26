import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { ServiceHelperService } from '../service-helper.service';
import { ServicepHelperService } from '../../../public/service/servicep-helper.service';
/**
 * [Importamos las Constantes]
 */

import { URL } from '../../../../constants/url.constant';


@Component({
  selector: 'app-favs',
  templateUrl: './favs.component.html',
  styleUrls: ['./favs.component.css']
})
export class FavsComponent implements OnInit {
  public subData: Subscription;
  public services;
  public url = URL.service;
  constructor(
    private serviceHelper: ServiceHelperService,
    private servicepHelper:ServicepHelperService
  ) { }

  ngOnInit() {
    this.getData();
  }

  /**
   * [Get Favs]
   */

  getData(){
    this.subData = this.serviceHelper.getFavs().subscribe( d => {
      this.services = d.s;
    })
  }

  /**
   * [Remove Favs]
   */

  removeFavs(service: any){
    this.services = this.services.filter(h => h !== service);
    this.servicepHelper.removeFavourite(service.service);
  }

  ngOnDestroy(){
    if(this.subData){this.subData.unsubscribe();}
  }
}
