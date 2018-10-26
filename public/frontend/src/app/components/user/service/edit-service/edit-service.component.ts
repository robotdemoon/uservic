import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Observable, Subscription } from 'rxjs';
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
  selector: 'app-edit-service',
  templateUrl: './edit-service.component.html',
  styleUrls: ['./edit-service.component.css']
})
export class EditServiceComponent implements OnInit {
  public subData: Subscription;
  public subImage: Subscription;

  public service;
  public idService;
  public contacts = [];
  public image;
  
  /**
   * [Constants]
   */
  
  public days = Days;
  public daysSelected = '';
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
    private route: ActivatedRoute,
    private imageService: ImageService,
    private serviceHelper: ServiceHelperService
  ) { 
    route.params.subscribe(val => {
      this.idService = this.route.snapshot.params.id;
    });
  }

  ngOnInit() {
    this.getData();
  }

  covertureChange(id,x){
    let a = this.coverture.covertureChange(id,x);
    (x == 'States') ? this.states$ = a: this.cities$ = a;
  }

  /**
   * [Get Service]
   */

  getData(){
    this.subData = this.serviceHelper.getService(this.idService).subscribe(d =>{
      this.covertureChange(d.s.country,'States');
      if(d.isState){this.covertureChange(d.s.state,'Cities');}
      this.image = d.s.image + this.imageService.generate();
      this.service = d.s;
      this.input.findCheckbox(this.days, this.service.business_days);
      this.daysSelected = this.input.filterCheckbox(this.days, true,false, 'value');
      this.service.business_days = this.input.filterCheckbox(this.days, true);
      this.contacts = d.c;
    });
  }

  /**
   * [Update Image]
   */

  imageUpdate(event: any){
    this.image = '../general/load.gif';
    //let g = this.imageService.generate();
    let a = this.imageService.updateImage(event, this.service.id, this.service.image);
    if(a != false){
      this.subImage = a.subscribe(d => {
        console.log(d);
        if(!d.e){
          this.service.image = d.image;
          this.image = d.image;// + g;
        }else{
          this.image = this.service.image;// + g;
          console.log(d);
        }
      });
    }else{
      this.image = this.service.image;// + g;
    }
  }

  /**
   * [Update Service]
   */
  updateService(){
    this.serviceHelper.updateService(this.service, this.contacts, this.idService);
  }

  ngOnDestroy(){
    if(this.subData){this.subData.unsubscribe();}
    if(this.subImage){this.subImage.unsubscribe();}
  }
}
