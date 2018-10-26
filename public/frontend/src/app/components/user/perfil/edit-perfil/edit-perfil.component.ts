import { Component, OnInit } from '@angular/core';
import { Observable, Subscription } from 'rxjs';
/**
 * [Importamos los Servicios]
 */

import { InputService } from '../../../../services/global/input/input.service';
import { ContactsService } from '../../../../services/crud/contacts/contacts.service';
import { CovertureService } from '../../../../services/crud/global/coverture/coverture.service';

/**
 * [Importar Constantes]
 */

import { CATEGORIES } from '../../../../constants/categories.constant';
import { SCHOLARSHIPS } from '../../../../constants/scholarship.constant';
import { INTERESTS } from '../../../../constants/interests.constant';
import { URL } from '../../../../constants/url.constant';
import { ImageService } from '../../../../services/crud/image/image.service';
import { PerfilHelperService } from '../perfil-helper.service';

@Component({
  selector: 'app-edit-perfil',
  templateUrl: './edit-perfil.component.html',
  styleUrls: ['./edit-perfil.component.css']
})
export class EditPerfilComponent implements OnInit {
  public subData: Subscription;
  /**
   * [Constantes]
   */

  public url = URL.user;
  public categories = CATEGORIES;
  public scholarships = SCHOLARSHIPS;
  public interests = INTERESTS; 

  /**
   * [Constantes Editables]
   */
  
  public user;
  public contacts = [];
  public countries$: Observable<any> = this.coverture.getCountries();
  public image;
  
  constructor(
    private input: InputService,
    private conts: ContactsService,
    private coverture: CovertureService,
    private imageService: ImageService,
    private perfilHelper: PerfilHelperService
  ) { }

  ngOnInit() {
    this.getData();
  }

  /**
   * Obtener la Información del Usuario
   */

  getData(){
    this.subData = this.perfilHelper.getData('Edit').subscribe(d =>{
      this.user = d.u;
      this.contacts = d.c;
      this.image = d.u.image;
      this.input.findCheckbox(this.interests, this.user.interests);
    });
  }

  /**
   * [Update Image]
   */

  imageUpdate(event: any){
    this.image = '../general/load.gif';
    let g = this.imageService.generate();
    let a = this.imageService.updateImage(event, 0, this.user.image);
    if(a != false){
      a.subscribe(d => {
        //Si no existe la imagen que se trae colocar la anterior
        if(!d.e){
          this.user.image = d.image;
          this.image = d.image + g;
        }else{
          this.image = this.user.image + g;
        }
      });
    }else{
      this.image = this.user.image + g;
    }
  }

  /**
   * [Editar Perfil]
   */

  savePerfil(){
    this.perfilHelper.updateData(this.user, this.contacts, this.interests);
  }

  ngOnDestroy(){
    if(this.subData){this.subData.unsubscribe();}
  }
}
