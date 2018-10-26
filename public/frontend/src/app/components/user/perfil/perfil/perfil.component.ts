import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
/**
 * [Importamos los Servicios]
 */
import { CrudService } from '../../../../services/crud/crud.service';

/**
 * [Importamos Constantes]
 */
import { URL } from '../../../../constants/url.constant';
import { PerfilHelperService } from '../perfil-helper.service';

@Component({
  selector: 'app-perfil',
  templateUrl: './perfil.component.html',
  styleUrls: ['./perfil.component.css']
})
export class PerfilComponent implements OnInit {
  public subData: Subscription;

  public url = URL.user;
  public user = [];
  public contacts = [];
  
  constructor(
    private crud: CrudService,
    private perfilHelper: PerfilHelperService
  ) { }

  ngOnInit() {
    this.getData();
  }

  /**
   * Obtener la Información del Usuario
   */
  getData(){
    this.subData = this.perfilHelper.getData().subscribe(d => {this.user = d.u; this.contacts = d.c});
  }

  ngOnDestroy(){
    if(this.subData){this.subData.unsubscribe();}
  }

}
