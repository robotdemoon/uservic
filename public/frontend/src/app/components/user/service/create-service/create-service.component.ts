import { Component, OnInit } from '@angular/core';
import { Observable, Subscription } from 'rxjs';
import { Service, Contact } from '../service.model';
import { CovertureService } from '../../../../services/crud/global/coverture/coverture.service';
import { DesignService } from '../../../../services/global/design.service';
import { InputService } from '../../../../services/global/input/input.service';
import { ContactsService } from '../../../../services/crud/contacts/contacts.service';
/**
 * [Importamos las constantes]
 */
import { Days } from '../../../../constants/days.constant';
import { CATEGORIES } from '../../../../constants/categories.constant';
import { URL } from '../../../../constants/url.constant';
import { TYPESERVICES } from '../../../../constants/service/type_service.constant';
import { TYPECOSTS } from '../../../../constants/service/type_cost.constant';
import { ImageService } from '../../../../services/crud/image/image.service';
import { ServiceHelperService } from '../service-helper.service';

@Component({
  selector: 'app-create-service',
  templateUrl: './create-service.component.html',
  styleUrls: ['./create-service.component.css']
})
export class CreateServiceComponent implements OnInit {
  public subData: Subscription;

  public service = new Service;
  public contacts = [new Contact(0)];
  public image;
  public image_name = 'nopicture.jpg';

  /**
   * [Constants]
   */
  
  public days = Days;
  public url = URL.service;
  public categories = CATEGORIES;
  public typeservices = TYPESERVICES;
  public typecosts = TYPECOSTS;
  /**
   * Observables
   */
  public countries$: Observable<any> = this.coverture.getCountries();
  public states$: Observable<any>;
  public cities$: Observable<any>;

  constructor(
    private coverture: CovertureService,
    private design: DesignService,
    private input: InputService,
    private conts: ContactsService,
    private imageService: ImageService,
    private serviceHelper: ServiceHelperService
  ) { }

  ngOnInit() {
    this.days.forEach(h => h.checked = false);
  }

  covertureChange(id,x){
    let a = this.coverture.covertureChange(id,x);
    (x == 'States') ? this.states$ = a: this.cities$ = a;
  }

  /**
   * [Agregar Imagen]
   */

  imageAdd(event: any){
    (event != undefined) ? this.image_name = '../general/load.gif':undefined;
    this.image = this.imageService.verigyImage(event);
  }

  /**
   * [Create Service]
   */

  createService(){
    this.subData = this.serviceHelper.createService(this.image, this.service, this.contacts).subscribe(d => {
      this.image_name = d.i;
    })
  }
  
  ngOnDestroy(){
    if(this.subData){this.subData.unsubscribe();}
  }
}
