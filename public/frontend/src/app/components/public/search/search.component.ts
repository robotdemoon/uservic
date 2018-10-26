import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs';
/**
 * [Importamos los Servicios]
 */

import { CrudService } from '../../../services/crud/crud.service';
import { QueryStructService } from '../../../services/global/query-struct/query-struct.service';

/**
 * [Importamos las Constantes]
 */

import { filter } from '../../../constants/search/filter.constant';
import { searchData } from '../../../constants/query-search.constant';
import { URL } from '../../../constants/url.constant';

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit {
  public url = URL.service;
  
  /**
   * [Variables de Metodos]
   */

  public subscription: Subscription;
  public subsQuery: Subscription;

  /**
   * [Variables de busqueda]
   */

  public filter = filter; 
  public searchData = searchData;
  public query = '';

  /**
   * [Otras variables]
   */

  public services = [];
  public max = 32;

  /**
   * [Variables de Estilo]
   */

  public h = false;
  
  constructor(
    private crud: CrudService,
    private route: ActivatedRoute,
    private QueryStruct: QueryStructService
  ) {

    /**
     * [Al cargar el componente se ejecuta el siguiente codigo]
     */

    this.subsQuery = this.route.queryParams.subscribe(params => {
      if(params['qr'] != undefined){
        if(this.searchData.query != this.searchData.l_query || !this.searchData.filter){
          this.query = this.QueryStruct.structQuery(params['qr']);
          this.searchData.l_query = this.query;
          this.searchData.more = true;
          this.h = false;
          this.searchService();
          this.searchData.filter = true;
        }else{
          if(this.searchData.data.length > 0){
            this.services = this.searchData.data;
          }
        }
      }
    });

  }

  ngOnInit() {
  }

  /**
   * [Funcion principal para la busqueda de servicios]
   */

  searchService(more: boolean = false, min: number = 0, max:number = this.max): void{
    if(this.searchData.more){
      if(more){
        min = this.services.length;
      }
      this.subscription = this.crud.implements(['search', 'services', 'get', 'Search'], '', {query:this.query, filter:this.filter, min: min, max: max}).subscribe(
      (d) => {
        console.log(d);
        if(d.length > 0 && (d.e == undefined || d.m == undefined)){
          if(!more){
            window.scrollTo(0, 0);
            this.services = d;
            if(d.length < max){
              this.h = true;
            }
          }else{
            for (const k in d) { this.services.push(d[k]);}
          }
          (d.length < max) ? this.searchData.more = false: this.searchData.more = true;
        }else{
          if(!more){
            this.services = [];
          }else{
            this.searchData.more = false;
          }
        }
        this.searchData.data = this.services;
      });
    }else{
      this.h = true;
    }
  }

  /**
   * [Eliminar la informacion al subscribirse a una funcion]
   */

  ngOnDestroy() {
      // unsubscribe to ensure no memory leaks
      this.subsQuery.unsubscribe();
      if(this.subscription != undefined){
        this.subscription.unsubscribe();
      }
  }
}
