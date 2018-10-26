import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { RequestHelperService } from './request-helper.service';
import { CostumerHelperService } from '../costumer-helper.service';
import { BUDGETNAV, IDBUDGETNAV } from '../budget-nav.constants';
@Component({
  selector: 'app-request-budget',
  templateUrl: './request-budget.component.html',
  styleUrls: ['./request-budget.component.css']
})
export class RequestBudgetComponent implements OnInit {
  /**
   * [Variables de Metodos]
   */
  public servicesSub: Subscription;

  public budgetRequests;
  public costumers;

  /**
   * [Variables de Navegación]
   */

  public budgetnav = BUDGETNAV;
  public idBudgetNav = IDBUDGETNAV;

  constructor(
    private requestHelper: RequestHelperService,
    private costumerHelper: CostumerHelperService
  ) { }

  ngOnInit() {
    this.getData();
  }
  
  getData(){
    this.requestHelper.getRequest('provider').subscribe( d => {
      this.budgetRequests = d.br;
    });
  }

  setData(r: any){
    this.budgetnav.costumer = +r.user;
    this.budgetnav.costumer_name = r.fullname;
    this.budgetnav.service = +r.service_id;
    this.budgetnav.request = +r.id;
    this.budgetnav.name_service = r.name_service;
  }
}
