import { Component, OnInit } from '@angular/core';
import { RequestHelperService } from '../request-helper.service';
import { IDBUDGETNAV } from '../../budget-nav.constants';

@Component({
  selector: 'app-my-requests',
  templateUrl: './my-requests.component.html',
  styleUrls: ['./my-requests.component.css']
})
export class MyRequestsComponent implements OnInit {
  public budgetRequests;

  public idBudgetNav = IDBUDGETNAV;
  
  constructor(
    private requestHelper: RequestHelperService
  ) { }

  ngOnInit() {
    this.getData();
  }
  
  getData(){
    this.requestHelper.getRequest('user').subscribe( d => {
      this.budgetRequests = d.br;
    });
  }

}
