import { Component, Input, Output, OnInit, EventEmitter } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common'
import { Observable } from 'rxjs';
/**
 * [Cargamos los Servicios]
 */

import { DesignService } from '../../../services/global/design.service';
import { QueryStructService } from '../../../services/global/query-struct/query-struct.service';
import { ArrayService } from '../../../services/global/array/array.service';
import { ConnectionService } from '../../../services/global/connection/connection.service';
import { InputService } from '../../../services/global/input/input.service';
import { CovertureService } from '../../../services/crud/global/coverture/coverture.service';

/**
 * [Importamos las Constantes]
 */

import { Filter, filter} from '../../../constants/search/filter.constant';
import { searchData } from '../../../constants/query-search.constant';
import { CATEGORIES } from '../../../constants/categories.constant';
import { Days } from '../../../constants/days.constant';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  /**
   * [Variables Externas]
   */

  @Input() public status = false;
  @Output() public navleft = new EventEmitter();

  /**
   * [Variables de Constantes]
   */

  public categories = CATEGORIES;
  public filter = filter;
  public searchData = searchData;
  public filterCompare = new Filter;

  /**
   * [Variables para el Select Days]
   */

  public days = Days;

  /**
   * [Coverture Observables]
   */
  
  public countries$: Observable<any> = this.coverture.getCountries();
  public states$: Observable<any>;
  public cities$: Observable<any>;

  /**
   * [Variables para la Busqueda]
   */
  
   public searchQuery = '';

  constructor(
    private design: DesignService,
    private input: InputService,
    private router: Router,
    private route: ActivatedRoute,
    private QueryStruct: QueryStructService,
    private array: ArrayService,
    private location: Location,
    private conn: ConnectionService,
    private coverture: CovertureService
  ) { 
    this.location = location;
    /**
     * [Se revisa que exista el (qr) que es la variable de busqueda en su caso se agrega a la variable del input]
     */
    this.route.queryParams.subscribe(params => {
      if(params['qr']){
        this.searchQuery = this.QueryStruct.structQuery(params['qr']);
        this.searchData.query = this.searchQuery;
      }
    });
  }

  ngOnInit() {
  }

  /**
   * [Get states and Cities]
   */
  covertureChange(id,x){
    let a = this.coverture.covertureChange(id,x);
    (x == 'States') ? this.states$ = a: this.cities$ = a;
  }
  
  /**
   * [Creamos la query para la busqueda]
   */

   createQuery(): void{
    if(this.searchQuery != ''){
      this.searchData.query = encodeURI(this.searchQuery.replace(/[\s]/g, '+'));
      if(!this.array.isEqual(this.filter, this.filterCompare) || this.searchData.query != this.searchData.l_query){
        this.searchData.filter = false;
      }else{
        this.searchData.filter = true;
      }
      this.router.navigate(['search'], {queryParams:{qr: this.searchData.query, n: Math.random()}, skipLocationChange: true });
      this.location.go('search', 'qr=' + this.searchData.query);
    }
   }

  /**
   * [Emite un evento para cambiar el estilo de la navleft]
  */

  navleftOperationStyle(): void{
    this.navleft.emit();
  }

}
