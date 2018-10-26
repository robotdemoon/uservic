import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { CrudService } from '../../../../services/crud/crud.service';

/**
 * [Add Constants]
 */
import { URL } from '../../../../constants/url.constant';

@Component({
  selector: 'app-my-services',
  templateUrl: './my-services.component.html',
  styleUrls: ['./my-services.component.css']
})
export class MyServicesComponent implements OnInit {
  public subData: Subscription;
  public subServices: Subscription;

  public services;
  public url = URL.service;
  constructor(
    private crud: CrudService
  ) { }

  ngOnInit() {
    this.subServices = this.crud.implements(['user', 'services', 'get', 'All'], 0, [], true).subscribe(d => this.services = d);
  }

  remove(service: any):void{
    this.services = this.services.filter(h => h !== service);
    this.subData = this.crud.implements(['user', 'services', 'remove'], 0, {service: +service.id}).subscribe();
  }

  ngOnDestroy(){
    if(this.subData){this.subData.unsubscribe();}
    if(this.subServices){this.subServices.unsubscribe();}
  }

}
