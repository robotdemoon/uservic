import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { BudgetHelperService } from '../budget-helper.service';
import { IDBUDGETNAV } from '../budget-nav.constants';

/**
 * [Importamos Constantes]
 */
import { URL } from '../../../../constants/url.constant';

@Component({
  selector: 'app-view-budget',
  templateUrl: './view-budget.component.html',
  styleUrls: ['./view-budget.component.css']
})
export class ViewBudgetComponent implements OnInit {

  /**
   * [Constantes]
   */
  
  public url = URL.service;

  /**
   * [Constantes de metodos]
   */

  public routeSub: Subscription;
  public budgetSub: Subscription;
  public idBudgetNav = IDBUDGETNAV;

  /**
   * [Variables de Componentes]
   */

  public budget;
  public budgetServices;
  public contacts;
  public networks;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private budgetHelper: BudgetHelperService
  ) { 
  }

  ngOnInit() {
    if(this.idBudgetNav.id != null){
      this.getData(+this.idBudgetNav.id, this.idBudgetNav.t);
      this.idBudgetNav.id = null;
      this.idBudgetNav.t = 'user';
    }else{
      this.router.navigate(['usr/budget/' + ( (this.idBudgetNav.t == 'user') ? 'my-request' : 'request')]);
    }
  }

  getData(id: number, t: string){
    this.budgetSub = this.budgetHelper.getViewBudget(+id, t).subscribe( d => {
      this.budget = d.b;
      this.budgetServices = d.bs;
      this.contacts = d.c;
      this.networks = d.n;
    });
  }

  ngOnDestroy(){
    if(this.budgetSub){this.budgetSub.unsubscribe();}
  }
}
