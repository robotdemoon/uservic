import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { CostumerHelperService } from './costumer-helper.service';
import { URL } from '../../../constants/url.constant';
@Component({
  selector: 'app-costumer',
  templateUrl: './costumer.component.html',
  styleUrls: ['./costumer.component.css']
})
export class CostumerComponent implements OnInit {

  /**
   * [Variables de Metodos]
   */
  public costumerSub: Subscription;

  /**
   * [Variables de Componentes]
   */
  public costumers;
  public url = URL.user;

  constructor(
    private costumerHelper: CostumerHelperService
  ) { }

  ngOnInit() {
    this.getData();
  }

  getData(){
    this.costumerHelper.getCostumers().subscribe( d => {
      this.costumers = d.c;
    });
  }

}
