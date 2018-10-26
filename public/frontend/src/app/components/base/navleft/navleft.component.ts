import { Component, Input, OnInit } from '@angular/core';
/**
 * [Importamos los Servicios]
 */
import { TokenService } from '../../../services/tkn/token.service';
@Component({
  selector: 'app-navleft',
  templateUrl: './navleft.component.html',
  styleUrls: ['./navleft.component.css']
})
export class NavleftComponent implements OnInit {
  
  /**
   * [Variables Externas]
   */

  @Input() public status = false;
  @Input() public navleftDisplay = false;

  constructor(
    private tkn: TokenService
  ) { }

  ngOnInit() {
  }
}
