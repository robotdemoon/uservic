import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { Router } from '@angular/router';
/**
 * [Importamos modelos y constantes]
 */
import {Budget, BudgetService } from '../budget.model';
import { BudgetHelperService } from '../budget-helper.service';
import { CostumerHelperService } from '../costumer-helper.service';
import { BUDGETNAV } from '../budget-nav.constants';

@Component({
  selector: 'app-create-budget',
  templateUrl: './create-budget.component.html',
  styleUrls: ['./create-budget.component.css']
})
export class CreateBudgetComponent implements OnInit {

  /**
   * [Variables de Metodos]
   */

  public servicesSub: Subscription;
  public costumersSub: Subscription;
  public routeSub: Subscription;

  /**
   * [Variables de Componentes]
   */
  
  public budget = new Budget;
  public budgetServices = [new BudgetService];
  public services = [];
  public costumers = [];
  public idRequest;
  /**
   * [Variables de Navegación]
   */
  public budgetnav = BUDGETNAV;

  constructor(
    private router: Router,
    private budgetHelper: BudgetHelperService,
    private costumerHelper: CostumerHelperService
  ) { 
  }

  ngOnInit() {
    if(this.budgetnav.costumer == '' || this.budgetnav.service == '' || this.budgetnav.request == null){
      this.router.navigate(['/usr/budget/request']);
    }else{
      this.idRequest = this.budgetnav.request;
      this.budget.costumer = this.budgetnav.costumer;
      this.budget.service = this.budgetnav.service;
    }
  }

}
