/*written in turbo c 2.0 */
#include<stdio.h>
int main(){
   unsigned char d[36884];
   long int i,j,base;
   long pos=36867L;
   FILE * fp=fopen("savegame.dat","rb");
   fread(d,1,36884L,fp);


   /*  map code dump
   base=16*9;
   for(i=0;i<256&&(i+base<256);i++){
     j=i/16;
     d[(i%16)+j*256]=i+base;

   }
   */
   /* find home  */
   for(i=0;i<0x8000;i++){
	if(d[i]==0x7c) {
		base=i;
		break;
	}
   }
   /* secure the base  */
   if(i<0x8000){
      for(i=-8;i<=8;i++){
	 for(j=-8;j<=8;j++){
		if (i*i+j*j>36){
		    d[base+i*256+j]=0x0f;
		}

	 }

      }

   }



   d[pos+0]=d[pos+1]=d[pos+2]=255;
   for(pos=0x8700L;pos<0x873fL;pos++){
     d[pos]=0xff;

   }

   fclose(fp);
   fp=fopen("savegame.dat","wb");
   fwrite(d,1,36884L,fp);
   fclose(fp);
   return 0;
}
