import { Component, Input, OnChanges, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';

/**
 * [Importamos las Constantes]
 */

import { URL } from '../../../../constants/url.constant';
import { ServicepHelperService } from '../servicep-helper.service';

@Component({
  selector: 'app-service-suggested',
  templateUrl: './service-suggested.component.html',
  styleUrls: ['./service-suggested.component.css']
})
export class ServiceSuggestedComponent implements OnInit {

  /**
   * [Variables Externas]
   */

  @Input() public category = '';
  @Input() public ncomments = 0;

  public url = URL.service;
  public services = [];
  /**
   * [Variables de Metodos]
   */

  public subscription: Subscription;

  constructor(
    private servicepHelper: ServicepHelperService
  ) {
  }

  ngOnInit() {
  }
  
  ngOnChanges() {
    this.getSuggestedServices();
  }

  getSuggestedServices(){
    let a = 0;let x = 3;
    (+this.ncomments >= 8) ? x = Math.trunc((+this.ncomments / 1.75) + 1):x = 3;
    this.subscription = this.servicepHelper.getServicesRelated(this.category, x).subscribe( d => {this.services = d.s;});
  }
  
  /**
   * [Eliminar la informacion al subscribirse a una funcion]
   */

  ngOnDestroy() {
      if(this.subscription != undefined){
        this.subscription.unsubscribe();
      }
  }
}
