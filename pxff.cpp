#include<stdio.h>
int main(int argc,char ** argv){
   unsigned char d[36884];
   long int i,j,base;
   long pos=36867L;
   unsigned char m;
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

   if(i<0x8000&&argc>=2){
      printf("Base located on : %x \n",base);
      sscanf(argv[1],"%x",&m);
      for(i=-8;i<=8;i++){
	 for(j=-8;j<=8;j++){
		if (i*i+j*j>36){
		    d[base+i*256+j]=m;
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
   printf("Written by zhblue . https://github.com/zhblue/PlanetX3-Tools\n");
   return 0;
}
