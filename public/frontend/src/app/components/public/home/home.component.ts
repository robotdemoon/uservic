import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { CrudService } from '../../../services/crud/crud.service';

/**
 * [importamos las constantes]
 */
import { home as h} from './home-constants.constants';
import { URL } from '../../../constants/url.constant';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  /**
   * [Creamos las variables de la vista]
   */
  public url = URL.service;
  public services;
  public categories = [];
  public previous_services = [];

  /**
   * [Variables de Metodos]
   */

  public sub: Subscription;

  constructor(
    private crud: CrudService
  ) { }

  ngOnInit() {
    if(h.categories == null && h.services == null ){
      this.getTop();
      this.getCategories();
    }else{
      this.services = h.services;
      this.categories = h.categories;
    }
    this.getPreviousServices();
  }

  getTop(){
    this.crud.implements(['search','services', 'get','Top']).subscribe(d => {
        if(d.length){ 
          this.services = {o: {}, s:{}, t:{}};
          this.services.o = d[0];
          this.services.s = d[1];
          this.services.t = d[2];
        }
      })
  }

  getCategories(){
    this.crud.implements(['search','services', 'get','Categories']).subscribe(d => {if(d.length) this.categories = d;})
  }

  /**
   * [Obtener los Servicios de busquedas previas]
   */

  getPreviousServices(){
    let a = JSON.parse(localStorage.getItem('previous_services'));
    if(a != undefined && a.length){
      this.previous_services = a;
    }
  }

  /**
   * [Desvinculacion]
   */

  ngOnDestroy() {
    if(this.sub != undefined){this.sub.unsubscribe();}
  } 
}
